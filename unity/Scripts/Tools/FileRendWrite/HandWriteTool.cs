using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using LitJson;
using System;
using System.IO;
public class HandWriteTool : MonoBehaviour
{
	
	//根据标签查找物体坐标
	public List<Record> WriteForFindTag(List<RAttribute> attrist,string filePath,string fileName )
	{
		int spriteCount = 0;
		if(attrist.Count == 0)
		{
			Debug.LogError("Tag 标签列表为空！");
			return null;
		}
		List<Record> recordList = new List<Record>();
		foreach(RAttribute ra in attrist )
		{
			GameObject[] mSprites = GameObject.FindGameObjectsWithTag(ra.tag);
			if( mSprites.Length == 0 )
			{
				Debug.LogError("找不到 "+ra.tag+" 标签物体！");
				return null;
			}
			Record mRecord = new Record();

			mRecord.randomSprite = ra.randomSprite;
			mRecord.maskType = ra.maskType;

			foreach(GameObject spr in mSprites)
			{
				//位置
				RVector3 pos = new RVector3();
				pos.x = (double)spr.transform.position.x;
				pos.y = (double)spr.transform.position.y;
				pos.z = (double)spr.transform.position.z;
				//方向
				RVector3 rota = new RVector3();
				rota.x = (double)spr.transform.rotation.eulerAngles.x;
				rota.y = (double)spr.transform.rotation.eulerAngles.y;
				rota.z = (double)spr.transform.rotation.eulerAngles.z;
				//大小
				mRecord.positionList.Add(pos);
				mRecord.rotationList.Add(rota);
				mRecord.scaleList.Add(spr.transform.localScale.x);

				spriteCount++;
			}
			recordList.Add(mRecord);
		}

 		WriteRecordList(recordList,filePath,fileName);
		print ( "共记录点 ： " + spriteCount );
		return recordList;
	}
	//记录点到txt中
	public void WriteRecordList(List<Record> vector3List ,string path,string name)
	{
		string mText = JsonMapper.ToJson(vector3List);

		FileInfo fileInfo = new FileInfo(path+"//"+ name+".txt");
		StreamWriter sw;
		if(fileInfo.Exists)
		{
			sw = fileInfo.CreateText();
		}
		else
		{
			sw = fileInfo.AppendText();
		}
		sw.WriteLine(mText);
		sw.Close();
		sw.Dispose();
	}
	//从txt中读取List<Vector3> 列表
	static public List<Record>  ReadRecordList(string path,string name )
	{

		FileInfo fileInfo = new FileInfo(path+"//"+ name+".txt");
		if(!fileInfo.Exists)
		{ 
			Debug.LogError(name+"文件不存在!");
		}
		StreamReader  fs = fileInfo.OpenText();
		string strOfRead = fs.ReadToEnd();
		List<Record> recordList = JsonMapper.ToObject<List<Record>>( strOfRead );
		return recordList;
	}
}
/// <summary>
/// 该类主要用于记录同一动画中 sprite图片 的位置，方向，大小及其一些属性。
/// 用List<Record> 来表示同一动画， sprite图片处在不同动画部件中。list中一元素表示一部件。
/// </summary>
public class Record
{
	public bool randomSprite = true; // 随机图片
	public MaskType maskType = MaskType.Circle;  //遮罩
	public bool isFaceForward = true;  //是否一直面向正前方
	public List<RVector3> positionList = new List<RVector3>(); //位置
	public List<RVector3> rotationList = new List<RVector3>();//方向
	public List<double> scaleList = new List<double>();//大小
	
}
//三维坐标
public class RVector3 
{
	public double x = 0;
	public double y = 0;
	public double z = 0;
}
//物体属性
[System.Serializable]
public class RAttribute
{
	public string tag = "";
	public bool randomSprite = true; // 随机图片
	public bool isFaceForward = true;  //是否一直面向正前方
	public MaskType maskType = MaskType.Circle;  //遮罩
}
//遮罩类型 
public enum  MaskType
{
	Non = -1,
	Circle = 0,
	CircularBead = 1,
	Square = 2
}