<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Socoda\Company\Test\Unit\Model;


class CompanyRepositoryTest extends \PHPUnit\Framework\TestCase
{
    protected $companyFactoryMock;
    protected $resourceModelMock;
    protected $companies;

    protected function setUp()
    {
        $this->companyFactoryMock = $this->getMockBuilder(
            \Socoda\Company\Model\CompanyFactory::class

        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->resourceModelMock = $this->getMockBuilder(
            \Socoda\Company\Model\ResourceModel\Company::class

        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRepository = new CompanyRepository(
            $this->companyFactoryMock,
            $this->resourceModelMock
        );

    }


    public function testSave($)
}