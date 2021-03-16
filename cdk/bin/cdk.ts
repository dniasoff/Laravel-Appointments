#!/usr/bin/env node
import 'source-map-support/register';
import * as cdk from '@aws-cdk/core';
import { CdkStack } from '../lib/cdk-stack';

const app = new cdk.App();
const serviceName = "laravel-demo";
new CdkStack(app, 'CdkStack-master',"master",serviceName);
new CdkStack(app, 'CdkStack-develop',"develop", serviceName);
new CdkStack(app, 'CdkStack-staging',"staging", serviceName);
