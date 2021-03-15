import * as cdk from '@aws-cdk/core';
import * as ecr from "@aws-cdk/aws-ecr";
import * as ecs from "@aws-cdk/aws-ecs";

export class CdkStack extends cdk.Stack {
  constructor(scope: cdk.Construct, id: string, props?: cdk.StackProps) {
    super(scope, id, props);

     // ECS Cluster
     const cluster = ecs.Cluster.fromClusterAttributes(this, "Cluster", {

     })


  }
  
}
