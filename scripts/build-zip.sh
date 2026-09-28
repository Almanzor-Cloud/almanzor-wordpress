#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
DIST="$ROOT/dist"
STAGE="$DIST/almanzor-cloud"
ZIP="$DIST/almanzor-cloud.zip"

rm -rf "$STAGE" "$ZIP"
mkdir -p "$STAGE"

rsync -a \
  --exclude '.git' \
  --exclude '.wordpress-org' \
  --exclude 'dist' \
  --exclude 'scripts' \
  --exclude '.DS_Store' \
  --exclude '*.zip' \
  "$ROOT/" "$STAGE/"

mkdir -p "$DIST"
(cd "$DIST" && zip -r "almanzor-cloud.zip" "almanzor-cloud")

echo "Built $ZIP"
