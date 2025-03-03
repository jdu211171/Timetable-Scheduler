#!/bin/bash
# build.sh - Cross-platform build script for Docker Stack TUI

# Create output directory
mkdir -p bin

# Build for Linux (amd64)
echo "Building for Linux (amd64)..."
GOOS=linux GOARCH=amd64 go build -o bin/docker-stack-linux-amd64

# Build for Linux (arm64) - for newer Macs or Raspberry Pi
echo "Building for Linux (arm64)..."
GOOS=linux GOARCH=arm64 go build -o bin/docker-stack-linux-arm64

# Build for macOS (amd64) - Intel Macs
echo "Building for macOS (amd64)..."
GOOS=darwin GOARCH=amd64 go build -o bin/docker-stack-macos-amd64

# Build for macOS (arm64) - Apple Silicon Macs
echo "Building for macOS (arm64)..."
GOOS=darwin GOARCH=arm64 go build -o bin/docker-stack-macos-arm64

# Build for Windows
echo "Building for Windows (amd64)..."
GOOS=windows GOARCH=amd64 go build -o bin/docker-stack-windows-amd64.exe

echo "All builds completed! Binaries are in the 'bin' directory."
