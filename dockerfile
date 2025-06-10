# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Set the working directory in the container to /app
WORKDIR /app

# Copy the entire contents of the 'frontend' directory from your host/repo into /app in the container
# This single COPY instruction should get all your files.
COPY frontend/ .

# Now that all files are copied, install dependencies based on the package.json now located at /app/package.json
RUN npm install

# Expose port 3000 (adjust if your app listens on a different port)
EXPOSE 3000

# Define the command to run your application
# Assumes your main server file is directly inside the 'frontend' directory (now /app)
CMD [ "node", "server.js" ]
