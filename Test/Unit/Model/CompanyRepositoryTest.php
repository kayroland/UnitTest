<?php

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
            ->setMethods(['create'])
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
            ->with($this->companyMock);

        $this->companyRepositoryMock->save($this->companyMock);
    }

    /**
     * @expectedException \Magento\Framework\Exception\CouldNotSaveException
     * * @expectedExceptionMessage Could not save company:
     */
    public function testSaveWithException()
    {

        $this->resourceModelMock->expects($this->once())
            ->method('save')
            ->with($this->companyMock)
            ->will($this->throwException(new \Exception()));

        $this->companyRepositoryMock->save($this->companyMock);
    }

    /**
     * @expectedException \Magento\Framework\Exception\NoSuchEntityException
     * @expectedExceptionMessage No such entity with id = 1
     */
    public function testGet()
    {
        $storeId = 10;
        $comId = 1;

        $this->companyMock = $this->getMockBuilder(\Socoda\Company\Model\Company::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->companyMock);

        $this->companyMock->expects($this->once())
            ->method('load')
            ->with($comId)
            ->willReturnSelf();

        $this->companyMock = $this->getMockBuilder(\Socoda\Company\Model\Company::class)
            ->setMethods(['getId'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyMock->expects($this->never())
            ->method('getId')
            ->willReturn($comId);

        $this->assertEquals($this->companyMock, $this->companyRepositoryMock->get($comId,$storeId));


    }

    public function testDelete()
    {
        $companyId = 1;

        $this->companyMock = $this->getMockBuilder(\Socoda\Company\Model\Company::class)
            ->setMethods(['getId'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyMock->expects($this->once())
            ->method('getId')
            ->willReturn($companyId);

        $this->resourceModelMock->expects($this->once())
            ->method('delete')
            ->with($this->companyMock);

        $this->assertTrue($this->companyRepositoryMock->delete($this->companyMock));

    }

    /**
     * @expectedException \Magento\Framework\Exception\StateException
     * @expectedExceptionMessage Cannot delete company with id
     */
    public function testDeleteWithException()
    {
        $companyId = 1;

        $this->companyMock = $this->getMockBuilder(\Socoda\Company\Model\Company::class)
            ->setMethods(['getId'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyMock->expects($this->any())
            ->method('getId')
            ->willReturn($companyId);

        $this->resourceModelMock->expects($this->once())
            ->method('delete')
            ->with($this->companyMock)
            ->willThrowException(new \Exception());

        $this->assertTrue($this->companyRepositoryMock->delete($this->companyMock));

    }

//    public function testDeleteById()
//    {
//        $comId = 10;
//
//        $this->resourceModelMock = $this->getMockBuilder(\Socoda\Company\Model\ResourceModel\Company::class)
//            ->setMethods(['get'])
//            ->disableOriginalConstructor()
//            ->getMock();
//
//        $this->resourceModelMock->expects($this->once())
//            ->method('get')
//            ->with(10)
//            ->willReturn(10);
//
//        $this->companyMock->expects($this->once())
//            ->method('load')
//            ->willReturnSelf();
//
//        $this->companyRepositoryMock->deleteById(10);
//
////        $this->assertSame($this->resourceModelMock, $result);
//
//
//    }



}