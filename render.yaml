# Exported from Render on 2025-08-02T00:57:53Z
services:
- type: web
  name: project_nabil
  runtime: docker
  repo: https://github.com/amjjjad120/project_nabil
  plan: free
  envVars:
  - key: DB_PASSWORD
    sync: false
  - key: DB_USER
    sync: false
  - key: DB_NAME
    sync: false
  region: frankfurt
  dockerContext: .
  dockerfilePath: ./Dockerfile
  autoDeployTrigger: commit
  rootDir: html
version: "1"
