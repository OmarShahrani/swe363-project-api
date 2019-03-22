<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic service interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Services extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function show_get($name = null)
    {

        if ($name === null) {
            $services = $this->db->get("services")->result();
        } else {
            $services = $this->db->get_where("services", array('name' => $name))->result();
        }

        // If the id parameter doesn't exist return all the services
        if ($services) {
            // Set the response and exit
            $this->response($services, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'No services were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function create_post()
    {
        $service = $this->post();

        if ($this->db->insert("services", $service)) {
            $service["id"] = $this->db->insert_id();
            $this->response($service, REST_Controller::HTTP_OK);
        } else {
            $this->response($this->db->error(), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_put()
    {
        $id = $this->put('id');

        if ($id !== null) {
            if ($this->db->where("id", $id)->update("services", $this->put())) {
                $this->response($this->db->get_where("services", array("id" => $id))->result(), REST_Controller::HTTP_OK);
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

        if ($this->db->delete('services', array("id" => $id))) {
            $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
        } else {

            $this->response(null, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
    }
}
