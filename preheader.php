<?php
if (isset($_GET['razdel']) && is_numeric($_GET['razdel'])) $razdel = $_GET['razdel']; else $razdel = NULL;
if (isset($_GET['uchr'])) $uchr = $_GET['uchr']; else $uchr = NULL;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) $edit = $_GET['edit']; else $edit = NULL;
if (isset($_GET['usluga']) && is_numeric($_GET['usluga'])) $usluga = $_GET['usluga']; else $usluga = NULL;