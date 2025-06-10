# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json from the 'frontend' directory
# This brings only the necessary files for npm install into /app
COPY frontend/package*.json ./

# Install any dependencies
RUN npm install

# Copy the rest of the application code from the 'frontend' directory into /app
# This should copy all other files/folders from 'frontend' into the root of /app
COPY frontend/. ./

# Expose port 3000 (adjust if your app listens on a different port)
EXPOSE 3000

# Define the command to run your application
# Assumes your main server file is directly in the 'frontend' directory
CMD [ "node", "server.js" ]
