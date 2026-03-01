<?php
if (empty($configuration['TEAMS_TENANT_ID'])) {
    throw new Exception('TEAMS_TENANT_ID is required');
}

if (empty($configuration['TEAMS_CLIENT_ID'])) {
    throw new Exception('TEAMS_CLIENT_ID is required');
}

if (empty($configuration['TEAMS_CLIENT_SECRET'])) {
    throw new Exception('TEAMS_CLIENT_SECRET is required');
}

echo "✓ Configuration validation passed\n";
?>
