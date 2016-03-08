using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using DG.Tweening;
/// <summary>
/// 球体动画
/// </summary>
public class SphereUnit : UnitProcessBase
{
	public float rotaSpeed = 10;
	public List<Vector3> path = new List<Vector3>();

	public FixedDirectionAllACT FixedFrom = new FixedDirectionAllACT();
	public FileRecordACT Sphere = new FileRecordACT();
	public FixedDirectionAllACT FixedEnd = new FixedDirectionAllACT();

	override public void Initialization()
	{
		AddToActionList(FixedFrom);
		AddToActionList(Sphere);
		AddToActionList(FixedEnd);
		base.Initialization();
	}
	//Tween开始时调用
	override protected void OnActStart(Transform spr,  int indexOfActList )
	{
		if( indexOfActList == 0 )
		{
			actionObjList[0].SendMessage( "TurnOnRota", rotaSpeed );
		}

	}
	//Tween结束时调用
	override protected void OnActEnd(Transform spr, int indexOfActList )
	{
		if( indexOfActList == 2 )
		{
			Invoke("TurnOffRota",2);
		}
	}
	/// 将动作插入到 动作 类之前
	override public void AppendToBefore( Sequence sequence, int indexOfActList )
	{
		AppendCamera(sequence,indexOfActList);
	}
	/// 在某个动作时加入该动作
	override public void JoinToSeqInTheAct(Sequence sequence, int indexOfActList)
	{

	}
	void TurnOffRota()
	{
		actionObjList[0].SendMessage( "TurnOffRota" );
	}
	void  AppendCamera(Sequence sequence, int indexOfActList )
	{
		if( indexOfActList !=  2)
		{
			return;
		}
		MyTool.ASSERT(path.Count == 4);
		Vector3[] paths = new Vector3[3];
		paths[0] = path[0];
		paths[1] = path[1];
		paths[2] = path[2];
		//paths[3] = path[3];
		Transform camere = Camera.main.transform;
	
		sequence.Append(camere.DOMove(path[0],5,false));
		sequence.AppendInterval(5);
		sequence.Append(camere.DOPath(paths,10,PathType.CatmullRom,PathMode.Full3D ,10,null));
		sequence.AppendInterval(5);
		sequence.Append(camere.DOMove(path[1],5,false));
		sequence.AppendInterval(5);
		sequence.Append(camere.DOMove(path[3],5,false));

	}

}
