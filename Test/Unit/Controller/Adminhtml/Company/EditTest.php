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
    protected $resultRedirectMock;
    protected $messageManagerMock;
    protected $configMock;
    protected $titleMock;
    protected $companyPrependMock;
    protected $breadMock;


    protected function setUp()
    {
        $this->resultPageFactoryMock = $this->getMockBuilder(\Magento\Framework\View\Result\PageFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultPageMock = $this->getMockBuilder(\Magento\Backend\Model\View\Result\Page::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->contextMock = $this->getMockBuilder(\Magento\Backend\App\Action\Context::class)
            ->setMethods(['getResultRedirectFactory', 'getMessageManager'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultRedirectFactoryMock = $this->getMockBuilder(\Magento\Framework\Controller\Result\RedirectFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultRedirectMock = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)
            ->setMethods(['setPath'])
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

        $this->companyRepositoryMock= $this->getMockBuilder(\Socoda\Company\Api\CompanyRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFactoryMock = $this->getMockBuilder(\Socoda\Company\Api\Data\CompanyInterfaceFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyMock = $this->getMockBuilder(\Socoda\Company\Api\Data\CompanyInterface::class)
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

        $this->companyRepositoryMock->expects($this->once())
            ->method('get')
            ->with(1,1)
            ->willReturn($this->companyMock);

        $this->companyMock = $this->getMockBuilder(\Socoda\Company\Api\Data\CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->registryMock->expects($this->once())
            ->method('register')
            ->with('current_company',$this->companyMock);

        $this->configMock = $this->getMockBuilder(\Magento\Framework\View\Page\Config::class)
            ->setMethods(['getTitle'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultPageMock->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->configMock);

        $this->titleMock = $this->getMockBuilder(\Magento\Framework\View\Page\Title::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock->expects($this->once())
            ->method('getTitle')
            ->willReturn($this->titleMock);

        $this->titleMock->expects($this->once())
            ->method('prepend');

        $this->resultPageMock->expects($this->once())
            ->method('addBreadcrumb')
            ->with(__('Company'), __('Company'))
            ->willReturnSelf();

        $this->assertSame($this->resultPageMock, $this->editControllerMock->execute());


    }

    public function testEditWithExeption()

    {
        $phrase = new \Magento\Framework\Phrase('No such entity.');
        $e = new \Magento\Framework\Exception\NoSuchEntityException($phrase);

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

        $this->companyRepositoryMock->expects($this->once())
            ->method('get')
            ->with(1, 1)
            ->willThrowException($e);

        $this->messageManagerMock->expects($this->once())
            ->method('addExceptionMessage')
            ->with($e,__('Something went wrong while editing the company.'));

        $this->resultRedirectFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->resultRedirectMock);

        $this->resultRedirectMock->expects($this->once())
            ->method('setPath')
            ->with('*/*/index')
            ->willReturnSelf();

        $this->assertSame($this->resultRedirectMock, $this->editControllerMock->execute());



    }

}


