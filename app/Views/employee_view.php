<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>- Employee -</title>
</head>
<body>
    <div class="form_section">
        <?php
        $session=@session();
        if($session->getFlashdata('message')){
            echo $session->getFlashdata('message');
        }

        ?>
        <form action="<?=base_url('employee')?>" enctype="multipart/form-data" method="post" id="add_form">
            <table>
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="emp_name" id="emp_name" value="<?=((isset($emp_details['employee_name']))?$emp_details['employee_name']:'')?>">
                    </td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>:</td>
                    <td>
                        <input type="file" name="emp_file" id="emp_file">
                        <img src="<?=(($emp_details['employee_file']!='')?base_url('load_image/'.$emp_details['employee_file']):'')?>" height="70" >
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>:</td>
                    <td>
                        <textarea name="emp_address" id="emp_address" ><?=((isset($emp_details['employee_address']))?$emp_details['employee_address']:'')?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>:</td>
                    <td>
                        <select name="emp_gender" id="emp_gender">
                            <option value="">-select-</option>
                            <option value="male" <?php echo ((isset($emp_details['employee_gender']) && ($emp_details['employee_gender'] == 'male'))?'selected':''); ?>>Male</option>
                            <option <?php echo ((isset($emp_details['employee_gender']) && ($emp_details['employee_gender'] == 'male'))?'selected':''); ?>>Female</option>
                          
                        </select>
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                    <input type="hidden" name="emp_edid" id="emp_edid" value="<?=((isset($emp_details['id']))?$emp_details['id']:'')?>">
                        <button type="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div>
    <form action="<?php echo base_url('employee/sort');?>" id="sort_form" method="post">
    <label for="sort_data"> Sort By : </label>
        <select name="sort_data" id="sort_data">
            <option value="id_desc">Id highest first</option>
            <option value="id_asc">Id lowest first</option>
            <option value="employee_asc">Name A-Z</option>
            <option value="employee_desc">Name Z-A</option>
        </select>
        <a href="#" onclick="gotopage();">sort</a>
    </form>
    </div>
    <div class="list_section">
    <?php
        if(isset($emp_data) && !empty(($emp_data))){
            //echo '<pre>';print_r($emp_details);echo '</pre>';
        ?>
        <table>
        <tr>
            <th>Id</a></th>
            <th>Name</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
            <?php
             foreach( $emp_data as $emp_d ){
            ?>
                <tr>
                    <td><?=$emp_d['id']?></td>
                    <td><?=$emp_d['employee_name']?></td>
                    <td><?=$emp_d['employee_address']?></td>
                    <td><?=$emp_d['employee_gender']?></td>
                    <td><img src="<?=(($emp_d['employee_file']!='')?base_url('load_image/'.$emp_d['employee_file']):'')?>" height="70" ></td>
                    <td>
                        <a href="<?=base_url('employee/ed/'.$emp_d['id'])?>">edit</a>
                        <a href="<?=base_url('employee/del/'.$emp_d['id'])?>">delete</a>
                    </td>
                </tr>
            <?php
            }
             ?>
        </table>
        <?php
        }
        ?>
        
          
    </div>
</body>
<script>
    function gotopage(){
        var value_sort = document.getElementById("sort_data").value;
        window.location.href = "<?php echo base_url('employee/sort/');?>/"+value_sort;
    }
</script>
</html>