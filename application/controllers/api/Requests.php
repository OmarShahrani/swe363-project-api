<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Requests extends REST_Controller
{

  private $table = "requests";

  function __construct()
  {
    // Construct the parent class
    parent::__construct();
  }

  public function show_get($id = null)
  {

    if ($id === null) {
      $requests = $this->db->get($this->table)->result();
    } else {
      $id = (int)$id;
      $requests = $this->db->get_where($this->table, array('id' => $id))->result();
    }
    // If the id parameter doesn't exist return all the services
    if ($requests) {
      // Set the response and exit
      $this->response($requests, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    } else {
      // Set the response and exit
      $this->response(array(), REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
    }
  }

  public function create_post()
  {
    $request = array(
      'service' => $this->post('service'),
      'requestedBy' => $this->post('requestedBy'),
      'assignedTo' => $this->post('assignedTo'),
      'requestedAt' => $this->post('requestedAt'),
      'status' => $this->post('status'),
    );

    if ($this->db->insert($this->table, $request)) {
      $request['id'] = $this->db->insert_id();
      $this->response($request, REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
    } else {
      $this->response(null, REST_Controller::HTTP_UNAUTHORIZED); // OK (200) being the HTTP response code
    }
  }

  public function update_put()
  {
    $id = $this->put('id');
    if ($id !== null) {
      if ($this->db->where("id", $id)->update($this->table, $this->put())) {
        $this->response($this->db->get_where($this->table, array("id" => $id))->result(), REST_Controller::HTTP_OK);
      } else {
        $this->response($this->db->error(), REST_Controller::HTTP_BAD_REQUEST);
      }
    } else {
      $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
    }
  }

  public function destroy_delete($id)
  {
    $id = (int)$id;
    $message = [
      'id' => $id,
      'message' => 'Deleted the resource'
    ];

    if ($this->db->delete($this->table, array("id" => $id))) {
      $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
    } else {

      $this->response(null, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
    }
  }
}
