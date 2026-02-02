<?php
echo "Admin: <code>" . password_hash("admin", PASSWORD_DEFAULT) . "</code><br/>";
echo "User: <code>" . password_hash("user", PASSWORD_DEFAULT) . "</code>";