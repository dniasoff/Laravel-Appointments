#!/bin/bash

 aws cloudformation get-template --stack-name laravel-demo-service-master --template-stage Processed | jq -r '.TemplateBody' > stack.yml
