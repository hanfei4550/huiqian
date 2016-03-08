using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class ActionLibrary 
{


}
[System.Serializable]
public class FileRecordACT:ActionBase
{
	[SerializeField]
	string fileName = "";
	override public void Initialization()
	{
		DoWithFileRecord();
	}
	/// <summary>
	/// 将txt文件中记录 转换为 配置流程.
	/// </summary>
	/// <returns>The turn to con process.</returns>
	void DoWithFileRecord()
	{
		string filePath = Application.dataPath+"/Record";//txt文件路径
		MyTool.ASSERT( filePath!="" && fileName!="","txt文件路径能为空或文件名为空！" );
		List<Record>  recordPartBox = HandWriteTool.ReadRecordList(filePath,fileName);
		//ActionBase mAction = new ActionBase();
		MyTool.ASSERT(recordPartBox.Count == TransPartBox.Count,"属性数量设置不对等！");
		for(int i=0; i<recordPartBox.Count; i++ )
		{
			//转换部件属性
			//PropertyPart mPropertyPart = new PropertyPart();
			//mPropertyPart.maskType = recordPartBox[i].maskType;
		//	mPropertyPart.randomSprite =  recordPartBox[i].randomSprite;
			//ProPropertyPartBox.Add(mPropertyPart);
			//转换部件基本信息
			//TransPart mTransPart = new TransPart();
			TransPartBox[i].maskType = recordPartBox[i].maskType;
			TransPartBox[i].randomSprite = recordPartBox[i].randomSprite;
			TransPartBox[i].isFaceForward = recordPartBox[i].isFaceForward;

			for(int k=0; k<recordPartBox[i].positionList.Count; k++ )
			{
				Vector3 pos = RTurnToVector(recordPartBox[i].positionList[k]);
				Vector3 rota = RTurnToVector(recordPartBox[i].rotationList[k]);

				TransPartBox[i].positionList.Add(pos);
				TransPartBox[i].rotationList.Add(rota);

				///spr图片总数计算
				spriteCount++;
			}
		}

	}

	// 将VRVector3转换为Vector3.
	Vector3 RTurnToVector(RVector3 rv)
	{
		return new Vector3( (float)rv.x, (float)rv.y, (float)rv.z);
	}
}

//*****************************************************固定移动点***************************************************************
/// <summary>
///固定方向移动点.
/// <比如所有点像上或向下移动>
/// </summary>
[System.Serializable]
public class FixedDirectionAllACT:ActionBase
{

	//固定移动点
	[SerializeField]
	Vector3 fixedDirection = Vector3.right;
	override public bool DependFile()//是否依赖txt文件中的记录
	{
		return true;
	}
	//初始化
	override public void Initialization( List<TransPart> orTransPartBox )
	{
		DudgeDirection( );// 判断移动方向
		SetTransPartBox( orTransPartBox );
	}

	void SetTransPartBox( List<TransPart> transPartBox )
	{
		MyTool.ASSERT(transPartBox.Count == TransPartBox.Count,"属性数量设置不对等！");
		for( int i=0; i<transPartBox.Count; i++ )
		{
			TransPart trPart = transPartBox[i];
			//TransPart mTransPart = new TransPart();
			//mTransPart.delayTime = trPart.delayTime;
			//mTransPart.transTime = trPart.transTime;
			TransPartBox[i].maskType = trPart.maskType;
			TransPartBox[i].randomSprite = trPart.randomSprite;
			TransPartBox[i].isFaceForward = trPart.isFaceForward;
			TransPartBox[i].isShow = false;
			for( int k=0; k<trPart.positionList.Count; k++ )
			{
				Vector3 pos = GetGoalPoint( trPart.positionList[k] );
				Vector3 rota = Quaternion.identity.eulerAngles;
				float scale = 1;

				TransPartBox[i].positionList.Add(pos);
				TransPartBox[i].rotationList.Add(rota);
				TransPartBox[i].scaleList.Add(scale);
				///spr图片总数计算
				spriteCount++;

			}
			//TransPartBox.Add(mTransPart);
		}
	}
	/// <summary>
	///  获取目标点.
	/// </summary>
	/// <returns>The goal point.</returns>
	/// <param name="point">Point.</param>
	public Vector3 GetGoalPoint( Vector3 point )
	{
		
		if( fixedDirection.x != 0)
		{
			point = new Vector3(fixedDirection.x ,point.y,point.z );
		}
		else if( fixedDirection.y != 0 )
		{
			point = new Vector3(point.x ,fixedDirection.y,point.z );
		}
		else
		{
			point = new Vector3(point.x ,point.y,fixedDirection.z );
		}
		return point;
	}
	/// <summary>
	/// 判断移动方向
	/// </summary>
	/// <returns>The direction.</returns>
	Vector3 DudgeDirection( )
	{
		if( fixedDirection.x != 0)
		{
			fixedDirection = Vector3.right*fixedDirection.x;
		}
		else if( fixedDirection.y != 0 )
		{
			fixedDirection = Vector3.up*fixedDirection.y;
		}
		else
		{
			fixedDirection = Vector3.forward*fixedDirection.z;
		}
		return fixedDirection;
	}
}
//*****************************************************************************************************************************



