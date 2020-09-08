<?php

namespace App\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @example:
 * ParamConverter(
 *      class="AppBundle\Model\MyRequest",
 *      converter="converter_name",
 *      options={"argument_name": "requestModel"}
 * )
 * if set argument_name in options than argument name will be equally argument_name (in example "requestModel")
 * else name will be equally name of class for conversion where first letter in lower case (i.e. "myRequest")
 *
 * Class AbstractRequestConverter
 */
abstract class AbstractRequestConverter implements ParamConverterInterface
{
    /**
     * @param Request        $request
     * @param ParamConverter $configuration
     *
     * @return void
     */
    public function apply(Request $request, ParamConverter $configuration): void
    {
        $attrName = $this->getAttrName($configuration);
        $requestObject = $this->convertRequestToObject($request, $configuration->getClass());

        $request->attributes->set($attrName, $requestObject);
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return (bool) $configuration->getClass() && $this->getConverterName() === $configuration->getConverter();
    }


    /**
     * @param Request $request
     * @param string  $className
     *
     * @return mixed
     */
    abstract protected function convertRequestToObject(Request $request, string $className);

    /**
     * @return string
     */
    abstract protected function getConverterName(): string;

    /**
     * @param ParamConverter $configuration
     *
     * @return string
     */
    private function getAttrName(ParamConverter $configuration): string
    {
        $configOptions = $configuration->getOptions();

        if (empty($configOptions['argument_name'])) {
            $classForConvert = $configuration->getClass();

            //class name where first letter in lower case
            return \lcfirst(substr($classForConvert, strrpos($classForConvert, '\\') + 1));
        }

        return $configOptions['argument_name'];
    }
}
