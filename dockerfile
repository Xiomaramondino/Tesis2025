# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json from the 'client' directory
# The first 'client/' refers to the path on your host (or in the Git repo)
# The './' refers to the current WORKDIR (/app) in the container
COPY client/package*.json ./

# Install any dependencies
RUN npm install

# Copy the rest of the application code
# This will copy everything from the root of your repo into /app
# If your main application code is ONLY within 'client', you might want:
# COPY client/. ./
COPY . .

# Expose port 3000 (adjust if your app listens on a different port)
EXPOSE 3000

# Define the command to run your application
# IMPORTANT: Adjust this path if your main entry file is in a subdirectory
# For example, if your server file is client/server.js:
CMD [ "node", "client/server.js" ]
