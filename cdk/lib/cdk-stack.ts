import * as cdk from '@aws-cdk/core';
import * as cfninc from '@aws-cdk/cloudformation-include';
import * as ecs from "@aws-cdk/aws-ecs";

export class CdkStack extends cdk.Stack {
  constructor(scope: cdk.Construct, id: string, branch: string, serviceName: string) {
    super(scope, id);


    const template = new cfninc.CfnInclude(this, 'Template', { 
      templateFile: 'stack.yml',
    });
      
    const laravelTask =  template.getResource("laravelTaskDef9B0924CC") as ecs.CfnTaskDefinition;

    const laravelTaskDefintionsArray =  laravelTask.containerDefinitions as Array<ecs.CfnTaskDefinition.ContainerDefinitionProperty>;


    let laravelTaskDefintion = laravelTaskDefintionsArray[1];

    

  }
  
}
