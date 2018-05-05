<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Socoda\Company\Test\Unit\Model\Company\Attribute\Source;
use Socoda\Company\Model\Company\Attribute\Source\Companies;


class CompaniesTest extends \PHPUnit\Framework\TestCase
{
    protected $companyCollectionFactoryMock;
    protected $companyCollectionMock;
    protected $companies;

    protected function setUp()
    {
        $this->companyCollectionFactoryMock = $this->getMockBuilder(
            \Socoda\Company\Model\ResourceModel\Company\CollectionFactory::class

        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->companies= new Companies(
            $this->companyCollectionFactoryMock
        );

    }

    public function testGetAllOptions()
    {



        $companyCollectionMock = $this->getMockBuilder(
            \Socoda\Company\Model\ResourceModel\Company\Collection::class

        )
            ->disableOriginalConstructor()
            ->getMock();

        $items = [$this->createMock(\Socoda\Company\Model\Company::class),
                  $this->createMock(\Socoda\Company\Model\Company::class)];

        $this->companyCollectionFactoryMock->expects($this->once())
            ->method('create')
            ->will($this->returnValue($companyCollectionMock));

        $companyCollectionMock->expects($this->once())
            ->method('addAttributeToSelect')
            ->with('name')
            ->willReturnSelf();

        $companyCollectionMock->expects($this->once())
            ->method('setOrder')
            ->with('name','asc')
            ->willReturnSelf();

        $companyCollectionMock->expects($this->atLeastOnce())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator($items));

        $this->companies->getAllOptions();


    }


}
