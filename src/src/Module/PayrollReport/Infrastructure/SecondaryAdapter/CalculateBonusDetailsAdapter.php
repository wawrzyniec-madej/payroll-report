<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Infrastructure\SecondaryAdapter;

use App\Module\Bonus\UserInterface\PrimaryAdapter\CalculateBonusDetailsAdapter as CalculateBonusDetailsPrimary;
use App\Module\PayrollReport\Domain\Exception\CannotCalculateBonusDetailsException;
use App\Module\PayrollReport\Domain\Interface\CalculateBonusDetailsInterface;
use App\Module\PayrollReport\Domain\ValueObject\BonusDetails;
use App\Module\PayrollReport\Domain\ValueObject\BonusName;
use App\Module\PayrollReport\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;
use Exception;

final readonly class CalculateBonusDetailsAdapter implements CalculateBonusDetailsInterface
{
    public function __construct(
        private CalculateBonusDetailsPrimary $getBonusDetailsForEmployee
    ) {
    }

    public function calculate(
        Money $remunerationBase,
        YearsOfSeniority $yearsOfSeniority,
        Identifier $bonusId
    ): BonusDetails {
        try {
            $result = $this->getBonusDetailsForEmployee->get(
                [
                    'amount' => $remunerationBase->getAmount(),
                    'currency' => $remunerationBase->getCurrency()->value,
                ],
                $yearsOfSeniority->getValue(),
                $bonusId->getValue()
            );
        } catch (Exception) {
            throw CannotCalculateBonusDetailsException::create($bonusId);
        }

        return BonusDetails::create(
            new BonusName($result['name']),
            new Money(
                $result['bonus']['amount'],
                CurrencyEnum::from($result['bonus']['currency'])
            ),
            $remunerationBase
        );
    }
}
