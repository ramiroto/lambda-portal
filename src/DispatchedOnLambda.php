<?php declare(strict_types=1);

namespace Tlapi\LambdaPortal;

use Closure;
use ReflectionClass;

trait DispatchedOnLambda
{

    /**
     * Send to Lambda if not already running on Lambda
     */
    public function runOnLambda(Closure $something): void
    {
        if($this->job->getConnectionName() !== LambdaPortalService::CONNECTION_NAME && env('APP_ENV') === 'production') {
            $lambdaPortalService = new LambdaPortalService();
            $lambdaPortalService->sendJobToLambda($this->job);

            return ;
        }

        $something();
    }

}
