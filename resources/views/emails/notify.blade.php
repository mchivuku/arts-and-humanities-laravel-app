
<style type="text/css">
    tr {
        border: 1px solid #999;
    }
</style>


<h2>Job notification</h2>

<table style="border: 1px solid #999;">
    <thead>
     <th> Job Name </th>
     <th> Status </th>
     <th> Details </th>
    </thead>
    <tbody>

        <?php

            foreach($jobs as $job){
                echo "<tr>";
                echo sprintf("<td>%s</td><td>%s</td><td>%s</td>",$job["name"],$job["status"],$job["details"]);
                echo "</tr>";
            }

        ?>

    </tbody>
</table>




