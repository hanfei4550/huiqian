using UnityEngine;
using System.Collections;
using System.Collections.Generic;
/// <summary>
/// 爆炸效果
/// </summary>
[System.Serializable]
public class ExplosionACT : ActionBase 
{
	public float RadiusOfradius = 10;
	public Vector3 Center = Vector3.zero;
	//public bool FaceForward = true;  //是否一直面向正前方
	override public bool DependFile()//是否依赖txt文件中的记录
	{
		return true;
	}
	//初始化
	override public void Initialization( List<TransPart> orTransPartBox )
	{

		SetTransPartBox(orTransPartBox);
	}
	void SetTransPartBox( List<TransPart> orTransPartBox )
	{
		MyTool.ASSERT(orTransPartBox.Count == TransPartBox.Count,"属性数量设置不对等！");
		MyTool.ASSERT(orTransPartBox.Count == TransPartBox.Count,"属性数量设置不对等！");
		for( int i=0; i<orTransPartBox.Count; i++ )
		{
			TransPart trPart = orTransPartBox[i];
			TransPartBox[i].maskType = trPart.maskType;
			TransPartBox[i].randomSprite = trPart.randomSprite;
			TransPartBox[i].isFaceForward = trPart.isFaceForward;
			TransPartBox[i].isShow = false;
			for( int k=0; k<trPart.positionList.Count; k++ )
			{
				Vector3 pos = GetGoalPoint();
				Vector3 rota = Quaternion.identity.eulerAngles;
				float scale = 1;
				
				TransPartBox[i].positionList.Add(pos);
				TransPartBox[i].rotationList.Add(rota);
				TransPartBox[i].scaleList.Add(scale);
				///spr图片总数计算
				spriteCount++;
				
			}
		}
	}
	public Vector3 GetGoalPoint( )
	{
			Vector3 newPosition;
			float my = Random.Range(-RadiusOfradius,RadiusOfradius); 
			float yRadius= Mathf.Sqrt( RadiusOfradius*RadiusOfradius-my*my );
			float mx =  Random.Range(-yRadius,yRadius);
			float zRange =Mathf.Sqrt( yRadius*yRadius-mx*mx );
			float mz = Random.Range(-zRange,zRange);
			newPosition = new Vector3(mx,my,mz)+Center;
			return newPosition;
	}
}
