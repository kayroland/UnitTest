<?php

namespace Socoda\Company\Test\Unit\Model\Order\Address;


class ValidatorTest extends \PHPUnit\Framework\TestCase
{

    protected $validator;
    protected $addressMock;
    protected $directoryHelperMock;
    protected $countryFactoryMock;



    protected function setUp()
    {
        $this->addressMock = $this->getMockBuilder(
            \Magento\Sales\Model\Order\Address::class
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->directoryHelperMock = $this->getMockBuilder(\Magento\Directory\Helper\Data::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFactoryMock = $this->getMockBuilder(\Magento\Directory\Model\CountryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $eavConfigMock = $this->createMock(\Magento\Eav\Model\Config::class);
        $attributeMock = $this->createMock(\Magento\Eav\Model\Entity\Attribute::class);
        $attributeMock->expects($this->any())
            ->method('getIsRequired')
            ->willReturn(true);
        $eavConfigMock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue($attributeMock));

        $this->validator = new \Magento\Sales\Model\Order\Address\Validator(
            $this->directoryHelperMock,
            $this->countryFactoryMock,
            $eavConfigMock
        );
    }

    /**
     * @dataProvider dataProviderTestValidate
     *
     */
    public function testValidate($addressData, $email, $addressType, $expectedWarnings)
    {
        $this->addressMock->expects($this->any())
            ->method('hasData')
            ->will($this->returnValueMap($addressData));
        $this->addressMock->expects($this->once())
            ->method('getEmail')
            ->will($this->returnValue($email));
        $this->addressMock->expects($this->once())
            ->method('getAddressType')
            ->will($this->returnValue($addressType));
        $actualWarnings = $this->validator->validate($this->addressMock);
        $this->assertEquals($expectedWarnings, $actualWarnings);
    }

    /**
     * Provides address data for tests
     *
     * @return array
     */
    public function dataProviderTestValidate()
    {
        return [
            [
                [
                    ['parent_id', true],
                    ['postcode', true],
                    ['lastname', true],
                    ['street', true],
                    ['city', true],
                    ['email', true],
                    ['telephone', true],
                    ['country_id', true],
                    ['firstname', true],
                    ['address_type', true],
                    ['company', 'Magento'],
                    ['fax', '222-22-22'],
                ],
                'coffdsfds@co.com',
                'company',
                ['Address type doesn\'t match required options'],
            ],
            [
                [
                    ['parent_id', true],
                    ['postcode', true],
                    ['lastname', true],
                    ['street', true],
                    ['city', true],
                    ['email', true],
                    ['telephone', true],
                    ['country_id', true],
                    ['firstname', true],
                    ['address_type', true],
                    ['company', 'Magento'],
                    ['fax', '222-22-22'],
                ],
                'coffdsfds@co.com',
                'billing',
                [],
            ],
            [
                [
                    ['parent_id', true],
                    ['postcode', true],
                    ['lastname', true],
                    ['street', false],
                    ['city', true],
                    ['email', true],
                    ['telephone', true],
                    ['country_id', true],
                    ['firstname', true],
                    ['address_type', true],
                    ['company', 'Magento'],
                    ['fax', '222-22-22'],
                ],
                'co.co.co',
                'coco-shipping',
                [
                    'Street is a required field',
                    'Email has a wrong format',
                    'Address type doesn\'t match required options'
                ]
            ]
        ];
    }
}
