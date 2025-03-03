#!/bin/bash

# Function to check if a required tool is installed
check_tool() {
  if ! command -v "$1" &>/dev/null; then
    echo "Error: $1 is not installed. Please install it to proceed."
    exit 1
  fi
}

# Welcome message
echo "Setting up your Laravel backend development environment..."

# Check for required tools
check_tool git

# Clone the repository (if not already cloned)
if [ ! -d "Timetable-Scheduler" ]; then
  echo "Cloning the repository..."
  git clone https://github.com/jdu211171/Timetable-Scheduler || {
    echo "Error: Failed to clone the repository. Check your connection or repository URL."
    exit 1
  }
  cd Timetable-Scheduler
else
  echo "Repository already cloned. Pulling latest changes..."
  cd Timetable-Scheduler
  git pull || {
    echo "Error: Failed to pull latest changes."
    exit 1
  }
fi

# Determine the OS and architecture
OS=$(uname -s | tr '[:upper:]' '[:lower:]')
ARCH=$(uname -m)

# Map OS to binary naming convention
case "$OS" in
linux*) OS=linux ;;
darwin*) OS=darwin ;;
msys* | cygwin*) OS=windows ;;
*)
  echo "Error: Unsupported OS: $OS"
  exit 1
  ;;
esac

# Map architecture to binary naming convention
case "$ARCH" in
x86_64) ARCH=amd64 ;;
aarch64 | arm64) ARCH=arm64 ;;
*)
  echo "Error: Unsupported architecture: $ARCH"
  exit 1
  ;;
esac

# Define the binary name based on OS and architecture
if [ "$OS" == "windows" ]; then
  BINARY_NAME="docker-stack-windows-amd64.exe"
else
  BINARY_NAME="docker-stack-${OS}-${ARCH}"
fi

# Check if the binary exists in the bin folder
BINARY_PATH="backend/EduWaveLaravel/bin/$BINARY_NAME"
if [ ! -f "$BINARY_PATH" ]; then
  echo "Error: Binary $BINARY_NAME not found in backend/EduWaveLaravel/bin/."
  exit 1
fi

# Make the binary executable (not needed for Windows)
if [ "$OS" != "windows" ]; then
  chmod +x "$BINARY_PATH" || {
    echo "Error: Failed to make the binary executable."
    exit 1
  }
fi

# Launch the binary
echo "Launching $BINARY_NAME to set up your environment..."
if [ "$OS" == "windows" ]; then
  ./"$BINARY_PATH"
else
  ./"$BINARY_PATH"
fi

# Success message
echo "Setup complete! Follow any prompts from the tool to customize your stack (e.g., PHP version, web server, database)."
