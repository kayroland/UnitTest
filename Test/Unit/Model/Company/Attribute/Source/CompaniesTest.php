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

        $companiesMock = $this->getMockBuilder(
            \Socoda\Company\Model\Company\Attribute\Source\Companies::class

        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCollectionFactoryMock->expects($this->once())
            ->method('create')
            ->will($this->returnValue($companiesMock));

        $companiesMock->expects($this->once())
            ->method('addAttributeToSelect')
            ->with('name')
            ->willReturn($this->returnValue($companiesMock));

       $companiesMock->expects($this->once())
            ->method('setOrder')
           ->with('name','asc')
            ->will($this->returnValue($companiesMock));

        $result = $this->companies->getAllOptions();
        $this->assertSame($companiesMock, $result);
    }


}
