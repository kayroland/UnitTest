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
    protected $companyRepositoryMock;
    protected $companyMock;

    protected function setUp()
    {
        $this->resourceModelMock = $this->getMockBuilder(\Socoda\Company\Model\ResourceModel\Company::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyMock = $this->getMockBuilder(\Socoda\Company\Model\Company::class)
            ->setMethods(['save', 'load'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFactoryMock = $this->getMockBuilder(\Socoda\Company\Model\CompanyFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRepositoryMock = $this->getMockBuilder(\Socoda\Company\Model\CompanyRepository::class)
            ->setConstructorArgs([
                $this->companyFactoryMock,
                $this->resourceModelMock])
            ->setMethods(null)
            ->getMock();

    }


    public function testSaveWithoutException()
    {

        $this->resourceModelMock->expects($this->once())
            ->method('save')
            ->with($this->companyMock)
            ->willReturnSelf();

        $this->assertSame($this->companyMock, $this->companyRepositoryMock->save($this->companyMock));
    }

    public function testSaveWithException()
    {
//        $ex = 'fdf';
//        $errorMsg = new \Exception($ex);
//        $phrase = new \Magento\Framework\Phrase('Not save');
//        $e = new \Magento\Framework\Exception\CouldNotSaveException($phrase,$errorMsg);
        $errorMsg = 'fdfd';


        $this->resourceModelMock->expects($this->once())
            ->method('save')
            ->with($this->companyMock)
            ->willThrowException(new \Exception(__($errorMsg)));

       $this->companyRepositoryMock->save($this->companyMock);
    }


}