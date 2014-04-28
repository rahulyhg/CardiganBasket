<?php

class Maven_member_base_model {
	const PLUGIN_KEY = "maven_member";
	var $prefix = '';

	public function __construct() {
		global $wpdb;
		$this->prefix = $wpdb->prefix;
	}

	protected function get_table($table) {
		return $this->prefix . $table;
	}

	protected function get_results($query) {
		global $wpdb;

		$result = $wpdb->get_results($query);
		if ($wpdb->last_error) {
			//TODO: Log error
			return;
		}

		return $result;
	}

	protected function get_options($query) {
		global $wpdb;

		$option = $wpdb->get_results($query);
		if ($wpdb->last_error) {
			//TODO: Log error
			return;
		}

		$option = unserialize($option[0]->option_value);

		return $option;
	}

	/**
	 * JUST FOR TESTING PURPOSE
	 * @param <type> $data
	 * @return <type>
	 */
	protected function convert_to_json($data) {
		return json_encode($data);
	}

	/**
	 * JUST FOR TESTING PURPOSE
	 * Send ajax response, in JSON
	 * @param string $result
	 */
	protected function send_ajax_result($result,$json=true) {

		if ($json)
		{
			if (!is_array($result))
				$result= array("result"=>$result);

			$result = $this->convert_to_json($result);
		}
		echo $result;
		die();
	}

}

?>