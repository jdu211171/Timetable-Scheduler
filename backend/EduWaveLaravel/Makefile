.PHONY: build clean all linux-amd64 linux-arm64 macos-amd64 macos-arm64 windows

# Default target
all: clean linux-amd64 linux-arm64 macos-amd64 macos-arm64 windows

# Create bin directory
bin:
	mkdir -p bin

# Build for specific platforms
linux-amd64: bin
	@echo "Building for Linux (amd64)..."
	GOOS=linux GOARCH=amd64 go build -o bin/docker-stack-linux-amd64 -ldflags="-s -w" .

linux-arm64: bin
	@echo "Building for Linux (arm64)..."
	GOOS=linux GOARCH=arm64 go build -o bin/docker-stack-linux-arm64 -ldflags="-s -w" .

macos-amd64: bin
	@echo "Building for macOS (amd64)..."
	GOOS=darwin GOARCH=amd64 go build -o bin/docker-stack-macos-amd64 -ldflags="-s -w" .

macos-arm64: bin
	@echo "Building for macOS (arm64)..."
	GOOS=darwin GOARCH=arm64 go build -o bin/docker-stack-macos-arm64 -ldflags="-s -w" .

windows: bin
	@echo "Building for Windows (amd64)..."
	GOOS=windows GOARCH=amd64 go build -o bin/docker-stack-windows-amd64.exe -ldflags="-s -w" .

# Clean build artifacts
clean:
	@echo "Cleaning up..."
	rm -rf bin

# Build for current platform only
build: bin
	@echo "Building for current platform..."
	go build -o bin/docker-stack -ldflags="-s -w" .
