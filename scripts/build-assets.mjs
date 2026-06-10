#!/usr/bin/env node
/**
 * Minifie CSS/JS du projet vers assets/build/ et génère manifest.json.
 * Usage : npm run build  (depuis la racine du projet)
 */
import { readFileSync, writeFileSync, mkdirSync, existsSync } from 'node:fs';
import { dirname, join, basename } from 'node:path';
import { fileURLToPath } from 'node:url';
import { createHash } from 'node:crypto';
import CleanCSS from 'clean-css';
import { minify as minifyJs } from 'terser';

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = join(__dirname, '..');
const assetsRoot = join(root, 'assets');
const buildRoot = join(assetsRoot, 'build');
const config = JSON.parse(readFileSync(join(__dirname, 'assets.config.json'), 'utf8'));

const manifest = {
  built_at: new Date().toISOString(),
  files: {},
  hashes: {},
};

function hashContent(content) {
  return createHash('sha256').update(content).digest('hex').slice(0, 8);
}

function ensureDir(filePath) {
  mkdirSync(dirname(filePath), { recursive: true });
}

async function processCss(relativePath) {
  const src = join(assetsRoot, relativePath);
  if (!existsSync(src)) {
    console.warn(`  skip (missing): ${relativePath}`);
    return;
  }

  const input = readFileSync(src, 'utf8');
  const result = new CleanCSS({ level: 2 }).minify(input);
  if (result.errors?.length) {
    throw new Error(`CSS ${relativePath}: ${result.errors.join(', ')}`);
  }

  const outRel = `build/${relativePath.replace(/\.css$/i, '.min.css')}`;
  const outPath = join(assetsRoot, outRel);
  ensureDir(outPath);
  writeFileSync(outPath, result.styles, 'utf8');

  manifest.files[relativePath] = outRel;
  manifest.hashes[relativePath] = hashContent(result.styles);
  console.log(`  css  ${relativePath} → ${outRel}`);
}

async function processJs(relativePath) {
  const src = join(assetsRoot, relativePath);
  if (!existsSync(src)) {
    console.warn(`  skip (missing): ${relativePath}`);
    return;
  }

  const input = readFileSync(src, 'utf8');
  const result = await minifyJs(input, {
    compress: true,
    mangle: true,
    format: { comments: false },
  });

  if (!result.code) {
    throw new Error(`JS ${relativePath}: minification failed`);
  }

  const outRel = `build/${relativePath.replace(/\.js$/i, '.min.js')}`;
  const outPath = join(assetsRoot, outRel);
  ensureDir(outPath);
  writeFileSync(outPath, result.code, 'utf8');

  manifest.files[relativePath] = outRel;
  manifest.hashes[relativePath] = hashContent(result.code);
  console.log(`  js   ${relativePath} → ${outRel}`);
}

console.log('Building minified assets…\n');

for (const file of config.css ?? []) {
  await processCss(file);
}
for (const file of config.js ?? []) {
  await processJs(file);
}

const manifestPath = join(buildRoot, 'manifest.json');
ensureDir(manifestPath);
writeFileSync(manifestPath, JSON.stringify(manifest, null, 2), 'utf8');

console.log(`\nDone — ${Object.keys(manifest.files).length} files → assets/build/`);
console.log(`Manifest: assets/build/manifest.json`);
