==> Cloning from https://github.com/Xiomaramondino/Tesis2025
==> Checking out commit d017d98b6e6a75db62c8f18cb6589d7a3eac2c26 in branch main
#1 [internal] load build definition from Dockerfile
#1 transferring dockerfile: 614B done
#1 DONE 0.0s
#2 [internal] load metadata for docker.io/library/node:18-alpine
#2 ...
#3 [auth] library/node:pull render-prod/docker-mirror-repository/library/node:pull token for us-west1-docker.pkg.dev
#3 DONE 0.0s
#2 [internal] load metadata for docker.io/library/node:18-alpine
#2 DONE 0.6s
#4 [internal] load .dockerignore
#4 transferring context: 2B done
#4 DONE 0.0s
#5 [1/5] FROM docker.io/library/node:18-alpine@sha256:8d6421d663b4c28fd3ebc498332f249011d118945588d0a35cb9bc4b8ca09d9e
#5 resolve docker.io/library/node:18-alpine@sha256:8d6421d663b4c28fd3ebc498332f249011d118945588d0a35cb9bc4b8ca09d9e 0.0s done
#5 DONE 0.1s
#6 [internal] load build context
#6 transferring context: 5.67MB 0.4s done
#6 DONE 0.4s
#5 [1/5] FROM docker.io/library/node:18-alpine@sha256:8d6421d663b4c28fd3ebc498332f249011d118945588d0a35cb9bc4b8ca09d9e
#5 extracting sha256:f18232174bc91741fdf3da96d85011092101a032a93a388b79e99e69c2d5c870
#5 extracting sha256:f18232174bc91741fdf3da96d85011092101a032a93a388b79e99e69c2d5c870 0.1s done
#5 extracting sha256:dd71dde834b5c203d162902e6b8994cb2309ae049a0eabc4efea161b2b5a3d0e
#5 extracting sha256:dd71dde834b5c203d162902e6b8994cb2309ae049a0eabc4efea161b2b5a3d0e 1.2s done
#5 DONE 1.9s
#5 [1/5] FROM docker.io/library/node:18-alpine@sha256:8d6421d663b4c28fd3ebc498332f249011d118945588d0a35cb9bc4b8ca09d9e
#5 extracting sha256:1e5a4c89cee5c0826c540ab06d4b6b491c96eda01837f430bd47f0d26702d6e3 0.1s done
#5 extracting sha256:25ff2da83641908f65c3a74d80409d6b1b62ccfaab220b9ea70b80df5a2e0549 0.0s done
#5 DONE 2.0s
#7 [2/5] WORKDIR /app
#7 DONE 0.0s
#8 [3/5] COPY client/package*.json ./
#8 ERROR: lstat /home/user/.local/tmp/buildkit-mount1513646487/client: no such file or directory
------
 > [3/5] COPY client/package*.json ./:
------
Dockerfile:8
--------------------
   6 |     
   7 |     # Copy package.json and package-lock.json from the 'client' directory to the working directory
   8 | >>> COPY client/package*.json ./
   9 |     
  10 |     # Install any dependencies
--------------------
error: failed to solve: lstat /home/user/.local/tmp/buildkit-mount1513646487/client: no such file or directory
