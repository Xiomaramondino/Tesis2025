# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Set the working directory in the container
# All subsequent commands will run from /app inside the container.
WORKDIR /app

# Copy the entire contents of your 'frontend' directory
# from your GitHub repository into the /app directory in the container.
# THIS IS THE CRITICAL LINE THAT NEEDS THE SOURCE PATH TO BE CORRECT.
COPY frontend/ .

# Install Node.js dependencies
# This assumes your package.json is now at /app/package.json
RUN npm install

# Expose the port your application listens on
# Common for Node.js apps, adjust if yours uses a different port.
EXPOSE 3000

# Define the command to run your application when the container starts.
# This assumes your main server file is directly in the 'frontend' folder
# (which is now copied to /app in the container).
CMD [ "node", "server.js" ]
