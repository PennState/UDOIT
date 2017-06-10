<?php
/**
*	Copyright (C) 2014 University of Central Florida, created by Jacob Bates, Eric Colon, Fenel Joseph, and Emily Sachs.
*
*	This program is free software: you can redistribute it and/or modify
*	it under the terms of the GNU General Public License as published by
*	the Free Software Foundation, either version 3 of the License, or
*	(at your option) any later version.
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details.
*
*	You should have received a copy of the GNU General Public License
*	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*	Primary Author Contact:  Jacob Bates <jacob.bates@ucf.edu>
*/

require_once('../config/settings.php');

session_start();
$user_id = $_SESSION['launch_params']['custom_canvas_user_id'];
UdoitUtils::$canvas_base_url = $_SESSION['base_url'];
session_write_close();

$job_group = filter_input(INPUT_GET, 'job_group', FILTER_SANITIZE_STRING);

// get the non-finalize jobs
$sth = UdoitDB::prepare("SELECT id, data, job_type, status FROM job_queue WHERE job_type != 'finalize_report' AND job_group = :job_group AND user_id = :user_id");
$sth->bindValue(":job_group", $job_group);
$sth->bindValue(":user_id", $user_id);
$sth->execute();
$jobs = $sth->fetchAll();

// get the finalize job (this is done in 2 queries so we don't have to retrieve the results from the non-final jobs)
$sth = UdoitDB::prepare("SELECT * FROM job_queue WHERE job_type = 'finalize_report' AND job_group = :job_group AND user_id = :user_id");
$sth->bindValue(":job_group", $job_group);
$sth->bindValue(":user_id", $user_id);
$sth->execute();
$final_job = $sth->fetch();
$final_job['results'] = json_decode($final_job['results'], true);

$job_status = [];
foreach ($jobs as $job)
{
	$json = json_decode($job['data'], true);
	$job_status[] = [
		'type' => $json['scan_item'],
		'status' => $job['status']
	];
}

$result = [
	'reportID' => isset($final_job['results']['report_id']) ? $final_job['results']['report_id'] : null,
	'status' => $final_job['status'],
	'jobs' => $job_status
];

echo(json_encode($result));
