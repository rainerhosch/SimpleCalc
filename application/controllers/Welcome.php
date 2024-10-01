<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function index()
	{
		$this->load->view('v_home');
	}

	public function bus_transfer_calculation()
	{
		if ($this->input->is_ajax_request()) {
			$data_post = $this->input->post();
			$data_size = $data_post['data_size'];
			$data_unit = $data_post['data_unit'];
			$dataForConvertion = $data_size . $data_unit;
			$data_hasil_perhitungan = [];
			if ($data_unit == 'bit') {
				$data_hasil_perhitungan = [
					'format_desimal' => (int) $data_size,
					'format_binary' => (int) $data_size,
				];
			} else {
				$data_hasil_perhitungan = [
					'format_desimal' => $this->byte_to_bit($this->byteconvert_decimal($dataForConvertion)),
					'format_binary' => $this->byte_to_bit($this->byteconvert_binary($dataForConvertion))
				];
			}
			$response = [
				'code' => 200,
				'status' => true,
				'data' => $data_hasil_perhitungan
			];
		} else {
			$response = [
				'code' => 403,
				'status' => false,
				'data' => null
			];
		}
		echo json_encode($response);
	}

	public function byte_to_bit($size_data)
	{
		return (int) $size_data * 8;
	}

	public function byteconvert_binary($input)
	{
		preg_match('/(\d+)(\w+)/', $input, $matches);
		$unit = strtolower($matches[2]);
		switch ($unit) {
			case "byte":
				$output = $matches[1];
				break;
			case "kb":
				$output = $matches[1] * pow(1024, 1);
				break;
			case "mb":
				$output = $matches[1] * pow(1024, 2);
				break;
			case "gb":
				$output = $matches[1] * pow(1024, 3);
				break;
			case "tb":
				$output = $matches[1] * pow(1024, 4);
				break;
			case "pb":
				$output = $matches[1] * pow(1024, 5);
				break;
		}
		return $output;
	}
	public function byteconvert_decimal($input)
	{
		preg_match('/(\d+)(\w+)/', $input, $matches);
		$unit = strtolower($matches[2]);
		switch ($unit) {
			case "byte":
				$output = $matches[1];
				break;
			case "kb":
				$output = $matches[1] * 1000;
				break;
			case "mb":
				$output = $matches[1] * 1000 * 1000;
				break;
			case "gb":
				$output = $matches[1] * 1000 * 1000 * 1000;
				break;
			case "tb":
				$output = $matches[1] * 1000 * 1000 * 1000 * 1000;
				break;
			case "pb":
				$output = $matches[1] * 1000 * 1000 * 1000 * 1000 * 1000;
				break;
		}
		return $output;
	}
}