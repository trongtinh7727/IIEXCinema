<table id="table" class="table table-striped table-bordered nowrap mt-4" style="width:100%">

    <!-- Table Header -->
    <thead>
        <tr>
            <th>ID</th>
            <th>USERNAME</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
    </thead>

    <!-- Table body -->
    <tbody>
        <tr>
            <td>Fiona Green</td>
            <td>Chief Operating Officer (COO)</td>
            <td>San Francisco</td>
            <td>48</td>
            <td>2010/03/11</td>
            <td>$850,000</td>
            <td>
                <button name="btn_delete_employee" class="btn btn-outline-danger" onclick="confirmRemoval(this)">Delete</button>
                <button name="btn_edit_employee" class="btn btn-outline-secondary">Edit</button>
            </td>
        </tr>
    </tbody>

    <!-- Table footer -->
    <tfoot>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
        </tr>
    </tfoot>
</table>