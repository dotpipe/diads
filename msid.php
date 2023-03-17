<?php

if (!session_status())
	session_start();

echo session_id() . "***" . session_encode();