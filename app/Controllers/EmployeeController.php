<?php 
namespace App\Controllers;
helper('form');
class EmployeeController extends BaseController
{
    protected $session;
    protected $data;
    public function __construct(){
        //$this->session= \Config\Services::session();
    }
    public function index()
    {
        return view('welcome_message');
    }
    public function add_list(){
        if (strtolower(service('request')->getMethod()) === 'post') {
            $lastId = $this->get_file_data('get_last');
            //its a post
            $data = [
                'id'                => $lastId+1
                ,'employee_name'    => trim($this->request->getpost('emp_name'))
                ,'employee_address' => trim($this->request->getpost('emp_address'))
                ,'employee_gender'  => trim($this->request->getpost('emp_gender'))
            ];
            $data['employee_file'] = '';
            if($this->request->getFile('emp_file')){
                $file = $this->request->getFile('emp_file');
                if($file->getName()!=''){
                    $newName = $file->getRandomName();
                    $ext = $file->guessExtension();
                    $file->move(WRITEPATH . 'uploads',$newName);
                    $data['employee_file'] = $newName;
                }
                
            }
            if($this->get_file_data('all_data')!=''){
                $all_data = $this->get_file_data('all_data');
            }else{
                $all_data = [];
            }
            
            $all_data[]=$data;
            
            $myfile = fopen(WRITEPATH."save_data.txt", "w") or die("Unable to open file!");
            $txt = json_encode($all_data);
            fwrite($myfile, $txt);
            fclose($myfile);
            $data['emp_data'] = $this->get_file_data('all_data');
            return redirect('employee');
            
        }else{
            if (strtolower(service('request')->getMethod()) === 'get'){
                
            }
            $data['emp_data'] = $this->get_file_data('all_data');
            return view('employee_view',$data);
        }
        
    }
    public function get_file_data($return_type=''){
        $fileData = file_get_contents(WRITEPATH."save_data.txt", true);
        $fileData_array = json_decode($fileData,true);
        if($return_type=='get_last'){
            $last_id = 0;
            if(isset($fileData_array) && !empty($fileData_array)){
                //echo '<pre>';print_r($fileData_array[array_key_last($fileData_array)]);exit;
                $last_id = $fileData_array[array_key_last($fileData_array)]['id'];
            }
            return $last_id;
        }
        if($return_type == 'all_data'){
            return $fileData_array;
        }
        
    }
    public function read_file($filename=''){
        $file = '/writable/uploads/1715617402_71cc7bde6cc1b78f54e7.jpg';

        helper("filesystem");
        $path = WRITEPATH . 'uploads/';
        if($filename!=''){
            $fullpath = $path . $filename;
            $file = new \CodeIgniter\Files\File($fullpath, true);
            $binary = readfile($fullpath);
            return $this->response
                    ->setHeader('Content-Type', $file->getMimeType())
                    ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
                    ->setStatusCode(200)
                    ->setBody($binary);
        }
       
    }
}