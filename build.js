const fs = require('fs');
const path = require('path');

// Create dist directory if it doesn't exist
const distDir = path.join(__dirname, 'dist');
if (!fs.existsSync(distDir)) {
  fs.mkdirSync(distDir, { recursive: true });
}

// Copy assets directory
const assetsSrc = path.join(__dirname, 'assets');
const assetsDest = path.join(__dirname, 'dist', 'assets');

if (fs.existsSync(assetsSrc)) {
  copyRecursiveSync(assetsSrc, assetsDest);
  console.log('Assets copied to dist/assets');
} else {
  console.log('Assets directory not found, creating empty directory');
  fs.mkdirSync(assetsDest, { recursive: true });
}

// Copy index.html to dist
fs.copyFileSync(
  path.join(__dirname, 'index.html'),
  path.join(__dirname, 'dist', 'index.html')
);
console.log('index.html copied to dist');

// Copy API directory
const apiSrc = path.join(__dirname, 'api');
const apiDest = path.join(__dirname, 'dist', 'api');

if (fs.existsSync(apiSrc)) {
  copyRecursiveSync(apiSrc, apiDest);
  console.log('API copied to dist/api');
} else {
  console.log('API directory not found');
}

// Copy vercel.json to dist
fs.copyFileSync(
  path.join(__dirname, 'vercel.json'),
  path.join(__dirname, 'dist', 'vercel.json')
);
console.log('vercel.json copied to dist');

// Copy package.json to dist
fs.copyFileSync(
  path.join(__dirname, 'package.json'),
  path.join(__dirname, 'dist', 'package.json')
);
console.log('package.json copied to dist');

function copyRecursiveSync(src, dest) {
  const exists = fs.existsSync(src);
  const stats = exists && fs.statSync(src);
  const isDirectory = exists && stats.isDirectory();
  
  if (isDirectory) {
    if (!fs.existsSync(dest)) {
      fs.mkdirSync(dest, { recursive: true });
    }
    fs.readdirSync(src).forEach(childItemName => {
      copyRecursiveSync(
        path.join(src, childItemName),
        path.join(dest, childItemName)
      );
    });
  } else {
    fs.copyFileSync(src, dest);
  }
}

console.log('Build completed successfully!');