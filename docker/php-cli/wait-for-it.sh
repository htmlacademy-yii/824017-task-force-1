#!/bin/sh
# wait-for-postgres.sh

set -e

host="postgres"

until PGPASSWORD="$2" psql -h "$host" -U "$1" -c '\l'; do
  >&2 echo "Postgres is unavailable - sleeping"
  sleep 2
done

>&2 echo "Postgres is up"
