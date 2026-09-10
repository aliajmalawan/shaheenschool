<?php
session_start();

echo "<h2>Session Debug Info</h2>";
echo "<p><strong>PHP Session ID:</strong> " . session_id() . "</p>";
echo "<p><strong>Session Status:</strong> " . session_status() . "</p>";
echo "<p><strong>Session Name:</strong> " . session_name() . "</p>";

if (isset($_SESSION['visitor_session_id'])) {
    echo "<p><strong>Visitor Session ID (stored):</strong> " . $_SESSION['visitor_session_id'] . "</p>";
} else {
    echo "<p><strong>Visitor Session ID:</strong> NOT SET</p>";
}

echo "<h3>All Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h3>Server Info:</h3>";
echo "<p><strong>IP Address:</strong> " . $_SERVER['REMOTE_ADDR'] . "</p>";
echo "<p><strong>User Agent:</strong> " . $_SERVER['HTTP_USER_AGENT'] . "</p>";
?>
