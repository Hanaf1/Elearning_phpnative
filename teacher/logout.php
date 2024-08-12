<?php
// Mulai session
session_start();

// Menghapus semua data session
session_destroy();

// Redirect ke halaman login
header("Location: ../login.php");
exit();
