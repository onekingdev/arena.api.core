<html lang="en">
<head>
    <title>New Deployments</title>
</head>
<body>
New Soundblock Deployment Requests on <a  href="{{$link}}">{{env("APP_ENV") == "prod" ? "Production" : ucfirst(env("APP_ENV"))}}</a>

<hr>

@foreach($deployments as $objDeployment)
    @php
        $objAccount = $objDeployment->project->account;
        $strPlanName = $objAccount->activePlan->planType->value("plan_name") ?? "Simple Distribution";
    @endphp
    <p>Service Plan: {{$objAccount->account_name}} ({{$strPlanName}})</p>
    <p>Project: {{$objDeployment->project->project_title}}</p>
    <p>Platforms: {{$objDeployment->platforms}}</p>
    <hr>
@endforeach

<a href="{{$link}}">View Deployments</a>
</body>
</html>
