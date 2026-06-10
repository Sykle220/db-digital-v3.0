#!/usr/bin/env bash
# Corrige les permissions de writable/ et uploads/ pour Apache (www-data).
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
WEB_GROUP="${WEB_GROUP:-www-data}"
WEB_USER="${WEB_USER:-$(whoami)}"

echo "==> Permissions CI4 : ${ROOT}/writable + uploads"
echo "    Propriétaire: ${WEB_USER}:${WEB_GROUP}"

chgrp -R "$WEB_GROUP" "$ROOT/writable" "$ROOT/uploads" 2>/dev/null || {
    echo "Note: chgrp nécessite d'être propriétaire ou root. Essayez: sudo $0"
    exit 1
}

find "$ROOT/writable" -type d -exec chmod 775 {} \;
find "$ROOT/writable" -type f -exec chmod 664 {} \;
find "$ROOT/uploads" -type d -exec chmod 775 {} \;
find "$ROOT/uploads" -type f -exec chmod 664 {} \;

chmod -R g+rwX "$ROOT/writable" "$ROOT/uploads"

echo "==> OK"
stat -c '  %U:%G %a %n' "$ROOT/writable" "$ROOT/writable/cache" "$ROOT/uploads"
