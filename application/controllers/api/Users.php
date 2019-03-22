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
class Users extends REST_Controller
{

    private $table = "users";

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        //$this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        //$this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        //$this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function show_get($id = null)
    {

        if ($id === null) {
            $users = $this->db->get($this->table)->result();
        } else {
            $id = (int)$id;
            $users = $this->db->get_where($this->table, array('id' => $id))->result();
        }
        foreach ($users as &$user) {
            unset($user->password);
        }
        unset($user);
        // If the id parameter doesn't exist return all the services
        if ($users) {
            // Set the response and exit
            $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function create_post()
    {
        $user = $this->post();
        $this->load->library('form_validation');

        $this->form_validation->set_data($user);
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == true) {
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
            if ($this->db->insert('users', $user)) {
                unset($user['password']);
                $user['id'] = $this->db->insert_id();
                $this->response($user, REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
            } else {
                $this->response(null, REST_Controller::HTTP_UNAUTHORIZED); // OK (200) being the HTTP response code
            }
        } else {

            $this->response($this->form_validation->error_array(), REST_Controller::HTTP_UNAUTHORIZED); // OK (200) being the HTTP response code
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

    /// login 
    public function login_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        if ($username !== null && $password !== null) {
            $query = $this->db->where(array("username" => $username))->get($this->table);

            if ($query->num_rows() === 1) {
                $user = $query->result();
                if (password_verify($password, $user[0]->password)) {
                    unset($user[0]->password);
                    $this->response($user[0], REST_Controller::HTTP_OK); // BAD_REQUEST (400) being the HTTP response code
                } else {
                    $this->response(null, REST_Controller::HTTP_UNAUTHORIZED); // BAD_REQUEST (400) being the HTTP response code
                }
            } else {
                $this->response(null, REST_Controller::HTTP_UNAUTHORIZED); // BAD_REQUEST (400) being the HTTP response code
            }
        } else {
            $this->response($this->post(), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
    }



    /// validators
    public function username_unique($str)
    {
        $row = $this->db->get_where('users', array('username'  => $str), 1)->row();
        if (isset($row)) {
            $this->form_validation->set_message('username_unique', 'The username has been already taken.');
            return false;
        } else {
            return true;
        }
    }
}
