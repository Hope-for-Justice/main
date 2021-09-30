<?php
// Bailout if class already defined.
if ( class_exists( 'Give_Zapier_Background_Process' ) ) {
	return;
}

/**
 * Class Give_Zapier_Background_Process
 *
 * @since 1.3.0
 *
 * Note: this class is only for internal use. it can me modify in future, so do not use this is production.
 */
final class Give_Zapier_Background_Process extends WP_Background_Process {
	/**
	 * Donation ID.
	 *
	 * @since 1.3.0
	 * @var int
	 */
	private $donation_id = 0;

	/**
	 * @var string
	 *
	 * @since 1.3.0
	 */
	protected $action = 'give_zapier_trigger';

	/**
	 * Task handler
	 *
	 * @param mixed $data
	 *
	 * @return mixed|void
	 * @since 1.3.0
	 */
	protected function task( $data ) {
		list( $new_status, $old_status, $donation ) = $data;

		// prevent duplicate donation status zapier trigger.
		$is_locked = ! Give_Zapier_Integration::$background_process->set_donation_lock( $donation, $new_status );

		if ( $is_locked ) {
			return false;
		}

		// handle zapier hook trigger when donation status changes.
		give_zapier_update_payment_status( $new_status, $old_status, $donation );

		return false;
	}

	/**
	 * Get memory limit
	 *
	 * @return int
	 * @since 1.3.0
	 *
	 */
	protected function get_memory_limit() {
		if ( function_exists( 'ini_get' ) ) {
			$memory_limit = ini_get( 'memory_limit' );
		} else {
			// Sensible default.
			$memory_limit = '128M';
		}

		if ( ! $memory_limit || '-1' === $memory_limit ) {
			// Unlimited, set to 32GB.
			$memory_limit = '32G';
		}

		return give_let_to_num( $memory_limit );
	}

	/**
	 * Set donation status lock
	 *
	 * @param $donation
	 * @param $new_status
	 *
	 * @return bool
	 * @since 1.3.0
	 *
	 */
	public function set_donation_lock( $donation, $new_status ) {
		$key = $this->get_donation_lock_key( $new_status );

		if ( '1' === give()->payment_meta->get_meta( $donation->ID, $key, true ) ) {
			return false;
		}

		give_update_meta( $donation->ID, $key, 1 );

		return true;
	}

	/**
	 * Get donation local key
	 *
	 * @param $new_status
	 *
	 * @return string
	 * @since 1.3.0
	 *
	 */
	public function get_donation_lock_key( $new_status ) {
		return "_give_zapier_{$new_status}_trigger_sent";
	}

	/**
	 * Is process running
	 *
	 * @since 1.3.0
	 *
	 * Check whether the current process is already running
	 * in a background process.
	 */
	public function is_process_running() {
		if ( get_transient( "{$this->identifier}_{$this->donation_id}_process_lock" ) ) {
			// Process already running.
			return true;
		}

		return false;
	}


	/**
	 * Is queue empty
	 *
	 * @return bool
	 * @since 1.3.0
	 *
	 */
	public function is_queue_empty() {
		global $wpdb;

		$table  = $wpdb->options;
		$column = 'option_name';

		$key = $wpdb->esc_like( "{$this->identifier}_{$this->donation_id}_batch_" ) . '%';

		$count = $wpdb->get_var( $wpdb->prepare( "
			SELECT COUNT(*)
			FROM {$table}
			WHERE {$column} LIKE %s
		", $key ) );

		return ! ( $count > 0 );
	}

	/**
	 * Get batch
	 *
	 * @return stdClass Return the first batch from the queue
	 * @since 1.3.0
	 *
	 */
	public function get_batch() {
		global $wpdb;

		$table        = $wpdb->options;
		$column       = 'option_name';
		$key_column   = 'option_id';
		$value_column = 'option_value';

		$key = "{$this->identifier}_{$this->donation_id}_batch_%";

		$query = $wpdb->get_row( $wpdb->prepare( "
			SELECT *
			FROM {$table}
			WHERE {$column} LIKE %s
			ORDER BY {$key_column} ASC
			LIMIT 1
		", $key ) );

		$batch       = new stdClass();
		$batch->key  = $query->$column;
		$batch->data = maybe_unserialize( $query->$value_column );

		return $batch;
	}

	/**
	 * Generate key
	 *
	 * Generates a unique key based on microtime. Queue items are
	 * given a unique key so that they can be merged upon save.
	 *
	 * @param int $length Length.
	 *
	 * @return string
	 */
	protected function generate_key( $length = 64 ) {
		$unique  = md5( microtime() . rand() );
		$prepend = "{$this->identifier}_{$this->donation_id}_batch_";

		return substr( $prepend . $unique, 0, $length );
	}

	/**
	 * Save queue
	 *
	 * @return $this
	 * @since 1.3.0
	 *
	 */
	public function save() {
		$key = $this->generate_key();

		if ( ! empty( $this->data ) ) {
			update_option( $key, $this->data );
		}

		return $this;
	}

	/**
	 * Update queue
	 *
	 * @param string $key  Key.
	 * @param array  $data Data.
	 *
	 * @return $this
	 * @since 1.3.0
	 *
	 */
	public function update( $key, $data ) {
		if ( ! empty( $data ) ) {
			update_option( $key, $data );
		}

		return $this;
	}

	/**
	 * Delete queue
	 *
	 * @param string $key Key.
	 *
	 * @return $this
	 * @since 1.3.0
	 *
	 */
	public function delete( $key ) {
		delete_option( $key );

		return $this;
	}

	/**
	 * Lock process
	 *
	 * Lock the process so that multiple instances can't run simultaneously.
	 * Override if applicable, but the duration should be greater than that
	 * defined in the time_exceeded() method.
	 *
	 * @since 1.3.0
	 */
	protected function lock_process() {
		$this->start_time = time(); // Set start time of current process.

		$lock_duration = ( property_exists( $this, 'queue_lock_time' ) ) ? $this->queue_lock_time : 60; // 1 minute
		$lock_duration = apply_filters( $this->identifier . '_queue_lock_time', $lock_duration );

		set_transient( "{$this->identifier}_{$this->donation_id}_process_lock", microtime(), $lock_duration );
	}

	/**
	 * Unlock process
	 *
	 * Unlock the process so that other instances can spawn.
	 *
	 * @return $this
	 * @since 1.3.0
	 *
	 */
	protected function unlock_process() {
		delete_transient( "{$this->identifier}_{$this->donation_id}_process_lock" );

		return $this;
	}

	/**
	 * Get query args
	 *
	 * @return array
	 */
	protected function get_query_args() {
		return array(
			'action'   => $this->identifier,
			'nonce'    => wp_create_nonce( $this->identifier ),
			'donation' => $this->donation_id,
		);
	}


	/**
	 * Set donation id
	 *
	 * @param $donation_id
	 *
	 * @return $this
	 * @since 1.3.0
	 *
	 */
	public function set_donation_id( $donation_id ) {
		$this->donation_id = $donation_id;

		return $this;
	}

	/**
	 * Maybe process queue
	 *
	 * Checks whether data exists within the queue and that
	 * the process is not already running.
	 */
	public function maybe_handle() {
		// Don't lock up other requests while processing
		session_write_close();

		if ( empty( $_POST['donation'] ) ) {
			wp_die();
		}

		$this->set_donation_id( absint( $_POST['donation'] ) );

		if ( $this->is_process_running() ) {
			// Background process already running.
			wp_die();
		}

		if ( $this->is_queue_empty() ) {
			// No data to process.
			wp_die();
		}

		check_ajax_referer( $this->identifier, 'nonce' );

		$this->handle();

		wp_die();
	}

	/**
	 * Schedule event
	 */
	protected function schedule_event() {
		$args = array( $this->donation_id );

		if ( ! wp_next_scheduled( $this->cron_hook_identifier, $args ) ) {
			wp_schedule_event( time(), $this->cron_interval_identifier, $this->cron_hook_identifier, $args );
		}
	}

	/**
	 * Handle cron healthcheck
	 *
	 * Restart the background process if not already running
	 * and data exists in the queue.
	 *
	 * @param int $donation_id
	 */
	public function handle_cron_healthcheck( $donation_id = 0 ) {
		if ( empty( $donation_id) ) {
			exit;
		}

		$donation_id = absint( $donation_id );

		$this->set_donation_id( absint( $donation_id ) );

		if ( $this->is_process_running() ) {
			// Background process already running.
			exit;
		}

		if ( $this->is_queue_empty() ) {
			// No data to process.
			$this->clear_scheduled_event();
			exit;
		}

		$this->handle();

		exit;
	}

	/**
	 * Clear scheduled event
	 *
	 */
	protected function clear_scheduled_event() {
		$args = array( $this->donation_id );

		$timestamp = wp_next_scheduled( $this->cron_hook_identifier, $args );

		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, $this->cron_hook_identifier, $args );
		}
	}
}
