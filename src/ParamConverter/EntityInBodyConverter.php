<?php
namespace App\ParamConverter;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @see: example in AbstractRequestConverter
 *
 * Class EntityInBodyConverter
 */
class EntityInBodyConverter extends AbstractRequestConverter
{
    protected const CONVERTER_NAME = 'entity_in_body_converter';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * EntityInBodyResolver constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @return string
     */
    protected function getConverterName(): string
    {
        return self::CONVERTER_NAME;
    }


    /**
     * @param Request $request
     * @param string  $className
     *
     * @return object
     * @throws \ReflectionException
     * @throws NotFoundHttpException
     */
    protected function convertRequestToObject(Request $request, string $className)
    {
        $requestContent = $request->getContent();

        $content = json_decode($requestContent, true);
        if (json_last_error()) {
            throw new BadRequestHttpException(sprintf('Request body does not have valid JSON: %s', json_last_error_msg()));
        }
        if (!isset($content['id'])) {
            throw new BadRequestHttpException(sprintf('Field "id" not found in body'));
        }

        $entityName = (new \ReflectionClass($className))->getShortName();

        try {
           $entity = $this->entityManager->find($className, $content['id']);
        } catch (\Exception $exception) {
            throw new BadRequestHttpException(sprintf("Can't found %s", $entityName), $exception);
        }

        if ($entity) {
            return $entity;
        }
        throw new NotFoundHttpException(sprintf('%s with id %s not found', $entityName, $content['id']));
    }
}
