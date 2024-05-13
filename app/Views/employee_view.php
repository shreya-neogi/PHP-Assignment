<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>- Employee -</title>
</head>
<body>
    <div class="form_section">
        <form action="<?=base_url('employee')?>">
            <table>
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="emp_name" id="emp_name">
                    </td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>:</td>
                    <td>
                        <input type="file" name="emp_file" id="emp_file">
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>:</td>
                    <td>
                        <textarea name="emp_address" id="emp_address"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>:</td>
                    <td>
                        <textarea name="emp_gender" id="emp_gender"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <button type="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="list_section">

    </div>
</body>
</html>