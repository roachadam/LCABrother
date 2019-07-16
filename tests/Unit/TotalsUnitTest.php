<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Goals;
use App\InvolvementLog;
use App\ServiceLog;
use App\Involvement;
use App\User;

class TotalsUnitTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Tests if the method $organization->getTotals() correctly works
     */
    public function test_get_totals()
    {
        //Arrange
        $user = $this->loginAsAdmin();

        $createdInvolvementPointsTotal = factory(InvolvementLog::class, 15)
            ->create([
                'organization_id' => $user->organization_id,
                'user_id' => $user->id
            ])
            ->pluck('involvement')
            ->sum('points');

        $serviceLogs = factory(ServiceLog::class, 3)->create([
            'user_id' => $user->id,
            'organization_id' => $user->organization_id,
        ]);

        $createdMoneyDonatedTotal = $serviceLogs->sum('money_donated');
        $createdHoursServedTotal = $serviceLogs->sum('hours_served');

        //Act
        $calculatedTotals = $user->organization->getTotals();

        //Assert
        $this->assertEquals($createdInvolvementPointsTotal, $calculatedTotals['points']);
        $this->assertEquals($createdMoneyDonatedTotal, $calculatedTotals['money']);
        $this->assertEquals($createdHoursServedTotal, $calculatedTotals['service']);
    }

    /**
     * Tests if the method $organization->getAverages() correctly works
     */
    public function test_get_averages()
    {
        //Arrange
        $user = $this->loginAsAdmin();
        $userId = factory(User::class, 5)
            ->create([
                'organization_id' => $user->organization_id
            ])
            ->push($user)
            ->pluck('id');

        $createdInvolvementPointsTotal = factory(InvolvementLog::class, 15)
            ->create([
                'organization_id' => $user->organization_id,
                'user_id' => $userId->random()
            ])
            ->pluck('involvement')
            ->sum('points');

        $serviceLogs = factory(ServiceLog::class, 20)->create([
            'user_id' => $user->id,
            'organization_id' => $user->organization_id,
        ]);

        $numUsers = $userId->count();

        $createdInvolvementAverage = $createdInvolvementPointsTotal / $numUsers;
        $createdMoneyAverage = $serviceLogs->sum('money_donated') / $numUsers;
        $createdHoursAverage = $serviceLogs->sum('hours_served') / $numUsers;

        //Act
        $calculatedAverages = $user->organization->getAverages();

        //Assert
        $this->assertEquals($createdInvolvementAverage, $calculatedAverages['points']);
        $this->assertEquals($createdMoneyAverage, $calculatedAverages['money']);
        $this->assertEquals($createdHoursAverage, $calculatedAverages['service']);
    }
}
