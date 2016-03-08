using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using DG.Tweening;
/// <summary>
/// 倒计时
/// </summary>
public class Countdown : UnitProcessBase {

	public FixedDirectionAllACT FixedFrom = new FixedDirectionAllACT();

	public FileRecordACT Number_five = new FileRecordACT();
	public ExplosionACT Explosion_five = new ExplosionACT();

	public FileRecordACT Number_four = new FileRecordACT();
	public ExplosionACT Explosion_four = new ExplosionACT();

	public FileRecordACT Number_two = new FileRecordACT();
	public ExplosionACT Explosion_two = new ExplosionACT();

	override public void Initialization()
	{
		AddToActionList(FixedFrom);
		AddToActionList(Number_five);
		AddToActionList(Explosion_five);
		AddToActionList(Number_four);
		AddToActionList(Explosion_four);
		AddToActionList(Number_two);
		AddToActionList(Explosion_two);

		SetOtherNumber(Number_four,Number_five);
		SetOtherExplosion(Explosion_four,Explosion_five);

		SetOtherNumber(Number_two,Number_five);
		SetOtherExplosion(Explosion_two,Explosion_five);

		base.Initialization();
	}
	void SetOtherNumber(ActionBase setAct,ActionBase formAct )
	{
		setAct.stayTime = formAct.stayTime;
		setAct.TransPartBox[0].delayTime = formAct.TransPartBox[0].delayTime ;
		setAct.TransPartBox[0].transTime = formAct.TransPartBox[0].transTime ;
		setAct.TransPartBox[0].ease =  formAct.TransPartBox[0].ease ;

	}
	void SetOtherExplosion( ActionBase setAct,ActionBase formAct )
	{
		ExplosionACT msetAct = (ExplosionACT)setAct;
		ExplosionACT mformAct = (ExplosionACT)formAct;
		msetAct.Center = mformAct.Center;
		msetAct.RadiusOfradius = mformAct.RadiusOfradius;

		SetOtherNumber(setAct,formAct);
	}
	//Tween开始时调用
	override protected void OnActStart( Transform spr,  int indexOfActList )
	{

	}

	//Tween结束时调用
	override protected void OnActEnd(Transform spr, int indexOfActList )
	{
	}
	/// 将动作插入到 动作 类之前
	override public void AppendToBefore( Sequence sequence, int indexOfActList )
	{
	}
	/// 在某个动作时加入该动作
	override public void JoinToSeqInTheAct(Sequence sequence, int indexOfActList)
	{
		
	}
}
