<?php

class Migrate extends CI_Controller
{

        public function index($version='latest')
        {
                $this->load->library('migration');
                if ($version==='latest'){

                        if ($this->migration->latest() === FALSE)
                        {
                                show_error($this->migration->error_string());
                        } 
                        else {
                                echo "migration done!!";
                        }
                }
                else {
                        if ($this->migration->current() === FALSE)
                        {
                                show_error($this->migration->error_string());
                        } 
                        else {
                                echo "migration done!!";
                        }   
                }
        }

}