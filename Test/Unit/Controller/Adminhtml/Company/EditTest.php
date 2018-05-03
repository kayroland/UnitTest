<?php

namespace Socoda\Company\Test\Unit\Controller\Adminhtml\Company;


class EditTest extends \PHPUnit\Framework\TestCase
{
    protected $editController;
    protected $editControllerMock;
    protected $resultPageFactoryMock;
    protected $resultPageMock;
    protected $resultForwardFactoryMock;
    protected $registryMock;
    protected $companyRepositoryMock;
    protected $companyMock;
    protected $companyFactoryMock;
    protected $contextMock;
    protected $getRequestMock;
    protected $resultRedirectFactoryMock;
    protected $messageManagerMock;


    protected function setUp()
    {
        $this->resultPageFactoryMock = $this->getMockBuilder(\Magento\Backend\Model\View\Result\PageFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->contextMock = $this->getMockBuilder(\Magento\Backend\App\Action\Context::class)
            ->setMethods(['getResultRedirectFactory', 'getMessageManager'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->resultRedirectFactoryMock = $this->getMockBuilder(\Magento\Framework\Controller\Result\RedirectFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->messageManagerMock = $this->getMockBuilder(\Magento\Framework\Message\ManagerInterfaceFactory::class)
            ->setMethods(['addExceptionMessage'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->contextMock->expects($this->once())
            ->method('getResultRedirectFactory')
            ->willReturn($this->resultRedirectFactoryMock);
        $this->contextMock->expects($this->once())
            ->method('getMessageManager')
            ->willReturn($this->messageManagerMock);

        $this->resultForwardFactoryMock = $this->getMockBuilder(\Magento\Framework\Controller\Result\ForwardFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->registryMock = $this->getMockBuilder(\Magento\Framework\Registry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->getRequestMock = $this->getMockBuilder(\Magento\Framework\App\RequestInterfaceFactory::class)
            ->setMethods(['getParam'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->editControllerMock = $this->getMockBuilder(\Socoda\Company\Controller\Adminhtml\Company\Edit::class)
            ->setConstructorArgs([
                $this->contextMock,
                $this->resultPageFactoryMock,
                $this->resultForwardFactoryMock,
                $this->registryMock,
                $this->companyRepositoryMock,
                $this->companyFactoryMock])
            ->setMethods(['getRequest'])
            ->getMock();
    }

    public function testEditWithoutExeption()
    {
        $this->resultPageMock = $this->getMockBuilder(\Magento\Backend\Model\View\Result\Page::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultPageFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->resultPageMock);

        $this->editControllerMock->expects($this->exactly(2))
            ->method('getRequest')
            ->willReturn($this->getRequestMock);
        $this->getRequestMock->expects($this->at(0))
            ->method('getParam')
            ->with('id')
            ->willReturn(1);
        $this->getRequestMock->expects($this->at(1))
            ->method('getParam')
            ->with('store', false)
            ->willReturn(1);
        $this->getRequestMock->expects($this->exactly(2))
            ->method('getParam');

        $this->companyRepositoryMock= $this->getMockBuilder(\Socoda\Company\Api\Data\CompanyInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $companyMock = $this->getMockBuilder(\Socoda\Company\Api\Data\CompanyInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
        $this->companyRepositoryMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($companyMock));

        $this->registryMock = $this->getMockBuilder(\Magento\Framework\Registry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->registryMock->expects($this->once())
            ->method('register')
            ->with('current_company',$companyMock);


        $this->assertSame($this->resultPageMock, $this->editControllerMock->execute());


    }


};


