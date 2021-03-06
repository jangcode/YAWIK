<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace Jobs\Factory\Paginator;

use Core\Repository\RepositoryService;
use Interop\Container\ContainerInterface;
use Laminas\Paginator\Paginator;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Factory creates a paginator to paginate all active organizations.
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @since 0.30
 */
class ActiveOrganizationsPaginatorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var RepositoryService $repositories
         * @var \Laminas\Http\PhpEnvironment\Request $request */
        $repositories   = $container->get('repositories');
        $repository     = $repositories->get('Jobs');
        $request        = $container->get('Request');
        $query          = $request->getQuery();
        $term           = $query->get('q');
        $cursor         = $repository->findActiveOrganizations($term);

        $adapter        = new \Core\Paginator\Adapter\DoctrineMongoCursor($cursor);
        $service        = new Paginator($adapter);

        return $service;
    }
}
