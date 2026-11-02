#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
DIST="$ROOT/dist"
STAGE="$DIST/almanzor"
ZIP="$DIST/almanzor.zip"

rm -rf "$STAGE" "$ZIP"
mkdir -p "$STAGE"

rsync -a \
  --exclude '.git' \
  --exclude '.wordpress-org' \
  --exclude 'dist' \
  --exclude 'scripts' \
  --exclude '.gitignore' \
  --exclude 'README.md' \
  --exclude 'WORDPRESS-ORG.md' \
  --exclude '.DS_Store' \
  --exclude '*.zip' \
  "$ROOT/" "$STAGE/"

mkdir -p "$DIST"
(cd "$DIST" && zip -r "almanzor.zip" "almanzor")

echo "Built $ZIP"
