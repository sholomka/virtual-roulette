<?php

/**
 * <p>Title: VirtualRoulette</p>
 *
 * <p>Description: VirtualRoulette IsBetValidResponse class</p>
 *
 * <p>Copyright: Copyright (c) 2013</p>
 *
 * <p>Company: Singular Group LLC</p>
 *
 * @author Shako Kakauridze
 * @version 1.0.0
 */

namespace Application\Core\Classes;


class IsValidResponse {
	
	private $isValid = false;
	private $betAmount = 0;
	
	public function setIsValid($isValid) {
		$this->isValid = $isValid;
	}
	
	public function setBetAmount($amount) {
		$this->betAmount = $amount;
	}
	
	public function getIsValid() {
		return $this->isValid;
	}
	
	public function getBetAmount() {
		return $this->betAmount;
	}
	
}
