<?php 
namespace App\Controllers;
helper('form');
class EmployeeController extends BaseController
{
    protected $session;
    protected $data;
    public function __construct(){
        $this->session= \Config\Services::session();
    }
    public function index()
    {
        return view('welcome_message');
    }
    public function add_list($type='',$id=''){
        if (strtolower(service('request')->getMethod()) === 'post') {
           
            if(trim($this->request->getpost('emp_name') && $this->request->getpost('emp_gender'))){
                $lastId = $this->get_file_data('get_last');
                //its a post
                $data = [
                    'id'                => $lastId+1
                    ,'employee_name'    => trim($this->request->getpost('emp_name'))
                    ,'employee_address' => trim($this->request->getpost('emp_address'))
                    ,'employee_gender'  => trim($this->request->getpost('emp_gender'))
                ];
                $data['employee_file'] = '';
                $newName = '';
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

                if(trim($this->request->getpost('emp_edid'))!=''){
                    if(isset($all_data) && !empty($all_data)){
                        foreach($all_data as $k=>$alld){
                            if($this->request->getpost('emp_edid') == $alld['id']){
                                $all_data[$k] = [
                                    'id'                => $this->request->getpost('emp_edid')
                                    ,'employee_name'    => trim($this->request->getpost('emp_name'))
                                    ,'employee_address' => trim($this->request->getpost('emp_address'))
                                    ,'employee_gender'  => trim($this->request->getpost('emp_gender'))
                                ];
                                if($data['employee_file'] != ''){
                                    $all_data[$k]['employee_file'] = $data['employee_file'];
                                }else{
                                    $all_data[$k]['employee_file'] = $alld['employee_file'];
                                }
                            }
                        }
                    }
                }else{
                    $all_data[]=$data;
                }
                $this->write_data($all_data);
            }else{
                $this->session->setFlashdata('message', 'please enter name and gender');
                return redirect('employee');
            }
            
            // $myfile = fopen(WRITEPATH."save_data.txt", "w") or die("Unable to open file!");
            // $txt = json_encode($all_data);
            // fwrite($myfile, $txt);
            // fclose($myfile);
            $data['emp_data'] = $this->get_file_data('all_data');
            return redirect('employee');
            
        }else{
            //echo $type;exit;
            $emp_data = $this->get_file_data('all_data');
            if($id!='' && $type=='ed'){
                $data['emp_details'] = $this->get_file_data('all_data',$id);
                $data['emp_data'] = $emp_data;
            }elseif($id!='' && $type=='del'){
            
                if(isset($emp_data) && !empty($emp_data)){
                    foreach($emp_data as $k=>$alld){
                        if($id == $alld['id']){
                            $unsetid= $k;
                            break;
                        }
                    }
                }
                //echo $unsetid;exit;
                unset($emp_data[$unsetid]);
                $data['emp_data'] = $emp_data;
                $this->write_data($emp_data);
            }elseif($type=='sort'){
                $emp_data = $this->sort_data($emp_data,$id);
                $data['emp_data'] = $emp_data;
            }
            else{
                $data['emp_data'] = $emp_data;
            }
            
            return view('employee_view',$data);
        }
        
    }
    public function sort_data($all_data=[],$sort_type='id_asc'){
        
           if(trim($sort_type) == 'id_asc'){
            array_multisort(array_column($all_data, 'id'), SORT_ASC, $all_data);
           }elseif (trim($sort_type) == 'id_desc') {
            array_multisort(array_column($all_data, 'id'), SORT_DESC, $all_data);
           }elseif (trim($sort_type) == 'employee_asc') {
            array_multisort(array_column($all_data, 'employee_name'), SORT_ASC, $all_data);
           }elseif (trim($sort_type) == 'employee_desc') {
            array_multisort(array_column($all_data, 'employee_name'), SORT_DESC, $all_data);
           }
        
        
        return $all_data;
    }
    private function write_data($all_data){
        $myfile = fopen(WRITEPATH."save_data.txt", "w") or die("Unable to open file!");
        $txt = json_encode($all_data);
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    private function get_file_data($return_type='',$id=''){
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
            if($id!=''){
                $details=[];
                foreach($fileData_array as $fileDataarr){
                    if($id==$fileDataarr['id']){
                        $details = $fileDataarr;
                    }
                }
                return $details;
            }else{
                return $fileData_array;
            }
            
        }
        if($return_type == 'remove'){
            if($id!=''){
                if(isset($fileData_array) && !empty($fileData_array)){
                    foreach($fileData_array as $k=>$fileDataarr){
                        if($id == $fileDataarr['id']){
                            return $k;
                        }
                    }
                }
            }
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