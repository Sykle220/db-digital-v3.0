#!/usr/bin/env bash
# Active mod_rewrite + routage CI4 (AllowOverride + FallbackResource)
# Requis une fois en local ; reproduire la même logique en prod (vhost ou conf).
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"

if [[ $EUID -ne 0 ]]; then
    echo "Ce script doit être lancé avec sudo :"
    echo "  sudo $ROOT/scripts/setup-apache.sh"
    exit 1
fi

echo "==> Apache — DB Digital Agency"

cp "$ROOT/scripts/apache-dbdigitalagency.conf" /etc/apache2/conf-available/dbdigitalagency.conf
a2enconf dbdigitalagency >/dev/null
a2enmod rewrite >/dev/null 2>&1 || true

if [[ ! -e /etc/apache2/sites-enabled/000-default.conf ]]; then
    a2ensite 000-default >/dev/null 2>&1 || true
fi

apache2ctl configtest
systemctl reload apache2

echo ""
echo "Apache configuré."
echo "  http://localhost/dbdigitalagency/public/fr/page-inexistante"
echo "  http://localhost/dbdigitalagency/fr/page-inexistante"
