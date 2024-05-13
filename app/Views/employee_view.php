<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>- Employee -</title>
</head>
<body>
    <div class="form_section">
        <form action="<?=base_url('employee')?>" enctype="multipart/form-data" method="post">
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
                        <input type="text" name="emp_gender" id="emp_gender" value="<?=((isset($emp_details['employee_gender']))?$emp_details['employee_gender']:'')?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                    <input type="text" name="emp_edid" id="emp_edid" value="<?=((isset($emp_details['id']))?$emp_details['id']:'')?>">
                        <button type="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="list_section">
    <?php
        if(isset($emp_data) && !empty(($emp_data))){
            echo '<pre>';print_r($emp_details);echo '</pre>';
        ?>
        <table>
        <tr>
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
</html>